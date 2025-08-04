<?php
require_once 'includes/session.php';
require_once 'config/database.php';
require_once 'classes/Task.php';

requireLogin();

$database = new Database();
$db = $database->getConnection();
$task = new Task($db);
$task->user_id = getUserId();

$message = '';
$error = '';

// Handle form submissions
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $task->title = $_POST['title'];
                $task->description = $_POST['description'];
                $task->due_date = $_POST['due_date'];
                $task->priority = $_POST['priority'];
                
                if ($task->create()) {
                    $message = "Task created successfully!";
                } else {
                    $error = "Unable to create task.";
                }
                break;
                
            case 'toggle_status':
                $task->id = $_POST['task_id'];
                $task->status = $_POST['new_status'];
                
                if ($task->updateStatus()) {
                    $message = "Task status updated!";
                } else {
                    $error = "Unable to update task status.";
                }
                break;
                
            case 'delete':
                $task->id = $_POST['task_id'];
                
                if ($task->delete()) {
                    $message = "Task deleted successfully!";
                } else {
                    $error = "Unable to delete task.";
                }
                break;
        }
    }
}

// Get tasks and stats
$stmt = $task->readByUser();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stats = $task->getStats();

$page_title = "Dashboard - TaskMaster";
include 'includes/header.php';
?>

<div class="container mt-4">
    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Tasks</h5>
                    <h2 class="text-primary"><?php echo $stats['total_tasks']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <h2 class="text-warning"><?php echo $stats['pending_tasks']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Completed</h5>
                    <h2 class="text-success"><?php echo $stats['completed_tasks']; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Create Task Form -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-plus"></i> Create New Task</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="create">
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date">
                        </div>
                        
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Create Task
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tasks List -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Your Tasks</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($tasks)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No tasks yet. Create your first task to get started!</p>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($tasks as $taskItem): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card priority-<?php echo $taskItem['priority']; ?> 
                                              <?php echo $taskItem['status'] === 'completed' ? 'task-completed' : ''; ?>">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title mb-0"><?php echo htmlspecialchars($taskItem['title']); ?></h6>
                                                <span class="badge bg-<?php echo $taskItem['priority'] === 'high' ? 'danger' : 
                                                    ($taskItem['priority'] === 'medium' ? 'warning' : 'success'); ?>">
                                                    <?php echo ucfirst($taskItem['priority']); ?>
                                                </span>
                                            </div>
                                            
                                            <?php if ($taskItem['description']): ?>
                                                <p class="card-text small text-muted">
                                                    <?php echo htmlspecialchars($taskItem['description']); ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <?php if ($taskItem['due_date']): ?>
                                                <p class="card-text small">
                                                    <i class="fas fa-calendar"></i> 
                                                    Due: <?php echo date('M j, Y', strtotime($taskItem['due_date'])); ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="action" value="toggle_status">
                                                    <input type="hidden" name="task_id" value="<?php echo $taskItem['id']; ?>">
                                                    <input type="hidden" name="new_status" 
                                                           value="<?php echo $taskItem['status'] === 'pending' ? 'completed' : 'pending'; ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-<?php echo $taskItem['status'] === 'pending' ? 'check' : 'undo'; ?>"></i>
                                                        <?php echo $taskItem['status'] === 'pending' ? 'Complete' : 'Undo'; ?>
                                                    </button>
                                                </form>
                                                
                                                <div>
                                                    <a href="edit_task.php?id=<?php echo $taskItem['id']; ?>" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" class="d-inline" onsubmit="return confirmDelete()">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="task_id" value="<?php echo $taskItem['id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

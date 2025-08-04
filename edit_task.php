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

// Get task ID from URL
$task_id = $_GET['id'] ?? null;

if (!$task_id) {
    header("Location: dashboard.php");
    exit();
}

$task->id = $task_id;

// Check if task exists and belongs to user
if (!$task->readOne()) {
    header("Location: dashboard.php");
    exit();
}

// Handle form submission
if ($_POST) {
    $task->title = $_POST['title'];
    $task->description = $_POST['description'];
    $task->due_date = $_POST['due_date'];
    $task->priority = $_POST['priority'];
    
    if ($task->update()) {
        $message = "Task updated successfully!";
        // Refresh task data
        $task->readOne();
    } else {
        $error = "Unable to update task.";
    }
}

$page_title = "Edit Task - TaskMaster";
include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit"></i> Edit Task
                        <a href="dashboard.php" class="btn btn-sm btn-outline-secondary float-end">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-success"><?php echo $message; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?php echo htmlspecialchars($task->title); ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($task->description); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" 
                                   value="<?php echo $task->due_date; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="low" <?php echo $task->priority === 'low' ? 'selected' : ''; ?>>Low</option>
                                <option value="medium" <?php echo $task->priority === 'medium' ? 'selected' : ''; ?>>Medium</option>
                                <option value="high" <?php echo $task->priority === 'high' ? 'selected' : ''; ?>>High</option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Task
                            </button>
                            <a href="dashboard.php" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

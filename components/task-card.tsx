"use client"

import { useState } from "react"
import { Card, CardContent, CardHeader } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import { Checkbox } from "@/components/ui/checkbox"
import { Calendar, Edit, Trash2 } from "lucide-react"
import type { Task } from "@/lib/types"
import { toggleTaskStatus, deleteTask } from "@/lib/task-actions"
import { TaskForm } from "./task-form"

interface TaskCardProps {
  task: Task
}

export function TaskCard({ task }: TaskCardProps) {
  const [isEditing, setIsEditing] = useState(false)
  const [loading, setLoading] = useState(false)

  const handleToggleStatus = async () => {
    setLoading(true)
    try {
      await toggleTaskStatus(task.id, task.status)
    } catch (error) {
      console.error("Error toggling task status:", error)
    } finally {
      setLoading(false)
    }
  }

  const handleDelete = async () => {
    if (confirm("Are you sure you want to delete this task?")) {
      setLoading(true)
      try {
        await deleteTask(task.id)
      } catch (error) {
        console.error("Error deleting task:", error)
      } finally {
        setLoading(false)
      }
    }
  }

  const getPriorityColor = (priority: string) => {
    switch (priority) {
      case "high":
        return "destructive"
      case "medium":
        return "default"
      case "low":
        return "secondary"
      default:
        return "default"
    }
  }

  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString()
  }

  if (isEditing) {
    return <TaskForm task={task} onCancel={() => setIsEditing(false)} />
  }

  return (
    <Card className={`transition-opacity ${task.status === "completed" ? "opacity-60" : ""}`}>
      <CardHeader className="pb-3">
        <div className="flex items-start justify-between">
          <div className="flex items-center space-x-2">
            <Checkbox checked={task.status === "completed"} onCheckedChange={handleToggleStatus} disabled={loading} />
            <h3 className={`font-semibold ${task.status === "completed" ? "line-through" : ""}`}>{task.title}</h3>
          </div>
          <div className="flex items-center space-x-1">
            <Badge variant={getPriorityColor(task.priority)}>{task.priority}</Badge>
            <Button variant="ghost" size="sm" onClick={() => setIsEditing(true)} disabled={loading}>
              <Edit className="h-4 w-4" />
            </Button>
            <Button variant="ghost" size="sm" onClick={handleDelete} disabled={loading}>
              <Trash2 className="h-4 w-4" />
            </Button>
          </div>
        </div>
      </CardHeader>

      {(task.description || task.due_date) && (
        <CardContent className="pt-0">
          {task.description && (
            <p className={`text-sm text-muted-foreground mb-2 ${task.status === "completed" ? "line-through" : ""}`}>
              {task.description}
            </p>
          )}
          {task.due_date && (
            <div className="flex items-center text-sm text-muted-foreground">
              <Calendar className="h-4 w-4 mr-1" />
              Due: {formatDate(task.due_date)}
            </div>
          )}
        </CardContent>
      )}
    </Card>
  )
}

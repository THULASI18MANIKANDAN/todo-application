export interface Task {
  id: string
  user_id: string
  title: string
  description: string | null
  due_date: string | null
  priority: "low" | "medium" | "high"
  status: "pending" | "completed"
  created_at: string
  updated_at: string
}

export interface User {
  id: string
  email: string
  user_metadata: {
    username?: string
  }
}

"use server"

import { createClient } from "@/lib/supabase/server"
import { revalidatePath } from "next/cache"
import { redirect } from "next/navigation"

export async function createTask(formData: FormData) {
  const supabase = await createClient()

  const {
    data: { user },
  } = await supabase.auth.getUser()

  if (!user) {
    redirect("/login")
  }

  const task = {
    user_id: user.id,
    title: formData.get("title") as string,
    description: formData.get("description") as string,
    due_date: (formData.get("due_date") as string) || null,
    priority: formData.get("priority") as "low" | "medium" | "high",
  }

  const { error } = await supabase.from("tasks").insert([task])

  if (error) {
    return { error: error.message }
  }

  revalidatePath("/dashboard")
}

export async function updateTask(id: string, formData: FormData) {
  const supabase = await createClient()

  const {
    data: { user },
  } = await supabase.auth.getUser()

  if (!user) {
    redirect("/login")
  }

  const updates = {
    title: formData.get("title") as string,
    description: formData.get("description") as string,
    due_date: (formData.get("due_date") as string) || null,
    priority: formData.get("priority") as "low" | "medium" | "high",
    updated_at: new Date().toISOString(),
  }

  const { error } = await supabase.from("tasks").update(updates).eq("id", id).eq("user_id", user.id)

  if (error) {
    return { error: error.message }
  }

  revalidatePath("/dashboard")
}

export async function toggleTaskStatus(id: string, currentStatus: string) {
  const supabase = await createClient()

  const {
    data: { user },
  } = await supabase.auth.getUser()

  if (!user) {
    redirect("/login")
  }

  const newStatus = currentStatus === "pending" ? "completed" : "pending"

  const { error } = await supabase
    .from("tasks")
    .update({
      status: newStatus,
      updated_at: new Date().toISOString(),
    })
    .eq("id", id)
    .eq("user_id", user.id)

  if (error) {
    return { error: error.message }
  }

  revalidatePath("/dashboard")
}

export async function deleteTask(id: string) {
  const supabase = await createClient()

  const {
    data: { user },
  } = await supabase.auth.getUser()

  if (!user) {
    redirect("/login")
  }

  const { error } = await supabase.from("tasks").delete().eq("id", id).eq("user_id", user.id)

  if (error) {
    return { error: error.message }
  }

  revalidatePath("/dashboard")
}

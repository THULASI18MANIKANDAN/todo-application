import Link from "next/link"
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { CheckSquare, Shield, Zap, Users } from "lucide-react"

export default function HomePage() {
  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
      <div className="container mx-auto px-4 py-16">
        {/* Hero Section */}
        <div className="text-center mb-16">
          <div className="flex justify-center mb-6">
            <CheckSquare className="h-16 w-16 text-blue-600" />
          </div>
          <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">TaskMaster</h1>
          <p className="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
            Organize your life with our powerful and intuitive to-do list application. Stay productive, meet deadlines,
            and achieve your goals.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button asChild size="lg">
              <Link href="/register">Get Started Free</Link>
            </Button>
            <Button variant="outline" size="lg" asChild>
              <Link href="/login">Sign In</Link>
            </Button>
          </div>
        </div>

        {/* Features Section */}
        <div className="grid md:grid-cols-3 gap-8 mb-16">
          <Card>
            <CardHeader>
              <Shield className="h-8 w-8 text-blue-600 mb-2" />
              <CardTitle>Secure & Private</CardTitle>
              <CardDescription>
                Your tasks are encrypted and stored securely. Only you can access your personal to-do lists.
              </CardDescription>
            </CardHeader>
          </Card>

          <Card>
            <CardHeader>
              <Zap className="h-8 w-8 text-blue-600 mb-2" />
              <CardTitle>Lightning Fast</CardTitle>
              <CardDescription>
                Built with modern technology for instant loading and real-time updates across all your devices.
              </CardDescription>
            </CardHeader>
          </Card>

          <Card>
            <CardHeader>
              <Users className="h-8 w-8 text-blue-600 mb-2" />
              <CardTitle>User Friendly</CardTitle>
              <CardDescription>
                Intuitive interface designed for productivity. Add, edit, and complete tasks with just a few clicks.
              </CardDescription>
            </CardHeader>
          </Card>
        </div>

        {/* CTA Section */}
        <Card className="bg-blue-600 text-white">
          <CardContent className="text-center py-12">
            <h2 className="text-3xl font-bold mb-4">Ready to Get Organized?</h2>
            <p className="text-blue-100 mb-6 text-lg">
              Join thousands of users who have transformed their productivity with TaskMaster.
            </p>
            <Button size="lg" variant="secondary" asChild>
              <Link href="/register">Start Your Journey</Link>
            </Button>
          </CardContent>
        </Card>
      </div>
    </div>
  )
}

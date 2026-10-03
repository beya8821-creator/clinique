import { AdminDashboard } from "@/components/dashboard/AdminDashboard";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function DashboardPage() {
  return (
    <AdminShell activePath="/dashboard" title="Dashboard">
      <AdminDashboard />
    </AdminShell>
  );
}

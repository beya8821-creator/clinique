import { UsersForm } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function UsersPage() {
  return (
    <AdminShell activePath="/dashboard/users" title="Users">
      <UsersForm />
    </AdminShell>
  );
}

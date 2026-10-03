import { SettingsForm } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function SettingsPage() {
  return (
    <AdminShell activePath="/dashboard/settings" title="Settings">
      <SettingsForm />
    </AdminShell>
  );
}

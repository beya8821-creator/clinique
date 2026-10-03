import { PagesEditor } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function ContentPagesPage() {
  return (
    <AdminShell activePath="/dashboard/content/pages" title="Pages avancees">
      <PagesEditor />
    </AdminShell>
  );
}

import { AddContentSectionForm } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function AddAboutSectionPage() {
  return (
    <AdminShell activePath="/dashboard/content/about/add" title="Ajouter - A propos">
      <AddContentSectionForm pageName="A propos" />
    </AdminShell>
  );
}

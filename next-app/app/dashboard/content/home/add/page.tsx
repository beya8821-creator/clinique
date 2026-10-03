import { AddContentSectionForm } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function AddHomeSectionPage() {
  return (
    <AdminShell activePath="/dashboard/content/home/add" title="Ajouter - Accueil">
      <AddContentSectionForm pageName="Accueil" />
    </AdminShell>
  );
}

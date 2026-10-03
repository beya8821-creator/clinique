import { AddContentSectionForm } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function AddServicesSectionPage() {
  return (
    <AdminShell activePath="/dashboard/content/services/add" title="Ajouter - Services">
      <AddContentSectionForm pageName="Services" />
    </AdminShell>
  );
}

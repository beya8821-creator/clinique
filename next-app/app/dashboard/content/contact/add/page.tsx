import { AddContentSectionForm } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function AddContactSectionPage() {
  return (
    <AdminShell activePath="/dashboard/content/contact/add" title="Ajouter - Contact">
      <AddContentSectionForm pageName="Contact" />
    </AdminShell>
  );
}

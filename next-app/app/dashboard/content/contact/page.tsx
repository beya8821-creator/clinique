import { CmsSectionsList, ContentSectionToolbar } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function ContentContactPage() {
  return (
    <AdminShell activePath="/dashboard/content/contact" title="Contact">
      <ContentSectionToolbar addHref="/dashboard/content/contact/add" label="Sections existantes du contact" />
      <CmsSectionsList editBaseHref="/dashboard/content/contact/edit" pageName="Contact" />
    </AdminShell>
  );
}

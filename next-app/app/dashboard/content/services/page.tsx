import { CmsSectionsList, ContentSectionToolbar } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function ContentServicesPage() {
  return (
    <AdminShell activePath="/dashboard/content/services" title="Services">
      <ContentSectionToolbar addHref="/dashboard/content/services/add" label="Sections existantes des services" />
      <CmsSectionsList editBaseHref="/dashboard/content/services/edit" pageName="Services" />
    </AdminShell>
  );
}

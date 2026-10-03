import { CmsSectionsList, ContentSectionToolbar } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function ContentAboutPage() {
  return (
    <AdminShell activePath="/dashboard/content/about" title="A propos">
      <ContentSectionToolbar addHref="/dashboard/content/about/add" label="Sections existantes de la page A propos" />
      <CmsSectionsList editBaseHref="/dashboard/content/about/edit" pageName="A propos" />
    </AdminShell>
  );
}

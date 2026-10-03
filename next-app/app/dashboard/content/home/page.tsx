import { CmsSectionsList, ContentSectionToolbar } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function ContentHomePage() {
  return (
    <AdminShell activePath="/dashboard/content/home" title="Accueil">
      <ContentSectionToolbar addHref="/dashboard/content/home/add" label="Sections existantes de l'accueil" />
      <CmsSectionsList editBaseHref="/dashboard/content/home/edit" pageName="Accueil" />
    </AdminShell>
  );
}

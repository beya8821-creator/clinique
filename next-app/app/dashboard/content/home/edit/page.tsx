import { CmsSectionEditForm } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

type EditPageProps = {
  searchParams: Promise<{ section?: string }>;
};

export default async function EditHomeSectionPage({ searchParams }: EditPageProps) {
  const { section } = await searchParams;

  return (
    <AdminShell activePath="/dashboard/content/home" title="Modifier - Accueil">
      <CmsSectionEditForm backHref="/dashboard/content/home" pageName="Accueil" sectionLabel={section} />
    </AdminShell>
  );
}

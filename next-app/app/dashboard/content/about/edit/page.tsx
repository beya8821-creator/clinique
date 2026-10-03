import { CmsSectionEditForm } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

type EditPageProps = {
  searchParams: Promise<{ section?: string }>;
};

export default async function EditAboutSectionPage({ searchParams }: EditPageProps) {
  const { section } = await searchParams;

  return (
    <AdminShell activePath="/dashboard/content/about" title="Modifier - A propos">
      <CmsSectionEditForm backHref="/dashboard/content/about" pageName="A propos" sectionLabel={section} />
    </AdminShell>
  );
}

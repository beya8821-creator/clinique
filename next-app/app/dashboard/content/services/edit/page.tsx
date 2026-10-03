import { CmsSectionEditForm } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

type EditPageProps = {
  searchParams: Promise<{ section?: string }>;
};

export default async function EditServicesSectionPage({ searchParams }: EditPageProps) {
  const { section } = await searchParams;

  return (
    <AdminShell activePath="/dashboard/content/services" title="Modifier - Services">
      <CmsSectionEditForm backHref="/dashboard/content/services" pageName="Services" sectionLabel={section} />
    </AdminShell>
  );
}

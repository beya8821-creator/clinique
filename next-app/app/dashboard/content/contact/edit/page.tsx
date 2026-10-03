import { CmsSectionEditForm } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

type EditPageProps = {
  searchParams: Promise<{ section?: string }>;
};

export default async function EditContactSectionPage({ searchParams }: EditPageProps) {
  const { section } = await searchParams;

  return (
    <AdminShell activePath="/dashboard/content/contact" title="Modifier - Contact">
      <CmsSectionEditForm backHref="/dashboard/content/contact" pageName="Contact" sectionLabel={section} />
    </AdminShell>
  );
}

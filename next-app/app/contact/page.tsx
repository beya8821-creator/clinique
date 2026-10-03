import { ContactPage } from "@/components/public/ContactPage";
import { PublicPageShell } from "@/components/public/PublicPageShell";

export default async function Contact({ searchParams }: PageProps<"/contact">) {
  const params = await searchParams;
  const status = typeof params.status === "string" ? params.status : undefined;

  return (
    <PublicPageShell activePath="/contact">
      <ContactPage status={status} />
    </PublicPageShell>
  );
}

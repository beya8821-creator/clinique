import { AppointmentPage } from "@/components/public/AppointmentPage";
import { PublicPageShell } from "@/components/public/PublicPageShell";

export default async function Appointment({ searchParams }: PageProps<"/appointment">) {
  const params = await searchParams;
  const status = typeof params.status === "string" ? params.status : undefined;

  return (
    <PublicPageShell activePath="/contact">
      <AppointmentPage status={status} />
    </PublicPageShell>
  );
}

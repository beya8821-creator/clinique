import { PublicPageShell } from "@/components/public/PublicPageShell";
import { ServiceDetailsPage } from "@/components/public/ServiceDetailsPage";

export default function ServiceDetails() {
  return (
    <PublicPageShell activePath="/services">
      <ServiceDetailsPage />
    </PublicPageShell>
  );
}

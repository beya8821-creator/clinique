import { PublicPageShell } from "@/components/public/PublicPageShell";
import { ServicesPage } from "@/components/public/ServicesPage";

export default function Services() {
  return (
    <PublicPageShell activePath="/services">
      <ServicesPage />
    </PublicPageShell>
  );
}

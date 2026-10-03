import { AboutPage } from "@/components/public/AboutPage";
import { PublicPageShell } from "@/components/public/PublicPageShell";

export default function About() {
  return (
    <PublicPageShell activePath="/about">
      <AboutPage />
    </PublicPageShell>
  );
}

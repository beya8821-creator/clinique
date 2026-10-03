import { HomePage } from "@/components/public/HomePage";
import { PublicPageShell } from "@/components/public/PublicPageShell";

export default function Home() {
  return (
    <PublicPageShell activePath="/">
      <HomePage />
    </PublicPageShell>
  );
}

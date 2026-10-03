import { HeroSliderManager } from "@/components/dashboard/HeroSliderManager";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function ContentHeroSliderPage() {
  return (
    <AdminShell activePath="/dashboard/content/hero-slider" title="Hero Slider">
      <HeroSliderManager />
    </AdminShell>
  );
}

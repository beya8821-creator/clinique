import { hasPublicSupabaseEnv } from "@/lib/config/env";
import { defaultHeroSlides, HeroSlide as PublicHeroSlide } from "@/lib/hero-slides";
import { createSupabaseServerClient } from "@/lib/supabase/server";

type HeroSliderRow = {
  display_order: number;
  id: number;
  image: string;
  status: boolean;
  subtitle: string | null;
  title: string | null;
};

function normalizeImagePath(imagePath: string) {
  if (imagePath.startsWith("http") || imagePath.startsWith("/")) {
    return imagePath;
  }

  return `/${imagePath}`;
}

export async function getPublishedHeroSlides(): Promise<PublicHeroSlide[]> {
  if (!hasPublicSupabaseEnv()) {
    return defaultHeroSlides;
  }

  try {
    const supabase = await createSupabaseServerClient();
    const { data, error } = await supabase
      .from("hero_slider")
      .select("id,image,title,subtitle,display_order,status")
      .eq("status", true)
      .order("display_order", { ascending: true });

    if (error || !data || data.length === 0) {
      return defaultHeroSlides;
    }

    const slides = data as unknown as HeroSliderRow[];

    return slides.map((slide) => ({
      alt: slide.subtitle || slide.title || "Image du hero Polyclinique Yetu",
      id: String(slide.id),
      image: normalizeImagePath(slide.image),
      status: "published",
      title: slide.title || `Slide ${slide.display_order + 1}`,
    }));
  } catch {
    return defaultHeroSlides;
  }
}

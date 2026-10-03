export type HeroSlide = {
  alt: string;
  id: string;
  image: string;
  status: "published" | "draft";
  title: string;
};

export const heroSliderStorageKey = "polyclinique-yetu-hero-slides";

export const defaultHeroSlides: HeroSlide[] = [
  {
    alt: "Personnel soignant de la Polyclinique Yetu",
    id: "hero-staff",
    image: "/assets/img/health/staff-10.webp",
    status: "published",
    title: "Personnel soignant",
  },
  {
    alt: "Plateau medical moderne de la Polyclinique Yetu",
    id: "hero-facility",
    image: "/assets/img/health/facilities-9.webp",
    status: "published",
    title: "Plateau medical",
  },
  {
    alt: "Equipe medicale attentive aupres des patients",
    id: "hero-team",
    image: "/assets/img/health/staff-8.webp",
    status: "published",
    title: "Equipe medicale",
  },
];

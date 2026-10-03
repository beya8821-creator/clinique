export type AdminNavigationItem = {
  badge?: string;
  children?: AdminNavigationChild[];
  href: string;
  icon: string;
  id: string;
  label: string;
  permission: string;
};

export type AdminNavigationChild = {
  href: string;
  id: string;
  label: string;
  permission: string;
};

export type AdminNavigationSection = {
  id: string;
  items: AdminNavigationItem[];
  label: string;
};

export const adminNavigation: AdminNavigationSection[] = [
  {
    id: "overview",
    label: "Vue generale",
    items: [
      {
        href: "/dashboard",
        icon: "bi-speedometer2",
        id: "dashboard",
        label: "Dashboard",
        permission: "dashboard.read",
      },
    ],
  },
  {
    id: "site",
    label: "Gestion du site",
    items: [
      {
        children: [
          { href: "/dashboard/content/home", id: "home-view", label: "Voir", permission: "content.home.read" },
          { href: "/dashboard/content/home/add", id: "home-add", label: "Ajouter", permission: "content.home.create" },
        ],
        href: "/dashboard/content/home",
        icon: "bi-house-heart",
        id: "home",
        label: "Accueil",
        permission: "content.home.read",
      },
      {
        children: [
          { href: "/dashboard/content/about", id: "about-view", label: "Voir", permission: "content.about.read" },
          { href: "/dashboard/content/about/add", id: "about-add", label: "Ajouter", permission: "content.about.create" },
        ],
        href: "/dashboard/content/about",
        icon: "bi-info-circle",
        id: "about",
        label: "A propos",
        permission: "content.about.read",
      },
      {
        children: [
          { href: "/dashboard/content/services", id: "services-view", label: "Voir", permission: "content.services.read" },
          { href: "/dashboard/content/services/add", id: "services-add", label: "Ajouter", permission: "content.services.create" },
        ],
        href: "/dashboard/content/services",
        icon: "bi-heart-pulse",
        id: "services",
        label: "Services",
        permission: "content.services.read",
      },
      {
        children: [
          { href: "/dashboard/content/contact", id: "contact-view", label: "Voir", permission: "content.contact.read" },
          { href: "/dashboard/content/contact/add", id: "contact-add", label: "Ajouter", permission: "content.contact.create" },
        ],
        href: "/dashboard/content/contact",
        icon: "bi-telephone",
        id: "contact",
        label: "Contact",
        permission: "content.contact.read",
      },
      {
        href: "/dashboard/content/pages",
        icon: "bi-code-square",
        id: "pages",
        label: "Pages HTML",
        permission: "content.pages.read",
      },
      {
        href: "/dashboard/content/hero-slider",
        icon: "bi-images",
        id: "hero-slider",
        label: "Hero Slider",
        permission: "content.hero.read",
      },
    ],
  },
  {
    id: "patients",
    label: "Patients",
    items: [
      {
        badge: "3",
        href: "/dashboard/appointments",
        icon: "bi-calendar2-week",
        id: "appointments",
        label: "Rendez-vous",
        permission: "appointments.read",
      },
      {
        badge: "5",
        href: "/dashboard/messages",
        icon: "bi-chat-left-text",
        id: "messages",
        label: "Messages",
        permission: "messages.read",
      },
      {
        href: "/dashboard/newsletter",
        icon: "bi-send",
        id: "newsletter",
        label: "Newsletter",
        permission: "newsletter.read",
      },
    ],
  },
  {
    id: "library",
    label: "Bibliotheque",
    items: [
      {
        href: "/dashboard/media",
        icon: "bi-folder2-open",
        id: "media",
        label: "Medias",
        permission: "media.read",
      },
    ],
  },
  {
    id: "administration",
    label: "Administration",
    items: [
      {
        href: "/dashboard/users",
        icon: "bi-people",
        id: "users",
        label: "Utilisateurs",
        permission: "users.read",
      },
      {
        href: "/dashboard/settings",
        icon: "bi-sliders",
        id: "settings",
        label: "Parametres",
        permission: "settings.read",
      },
      {
        href: "/dashboard/activity",
        icon: "bi-activity",
        id: "activity",
        label: "Activite",
        permission: "activity.read",
      },
    ],
  },
];

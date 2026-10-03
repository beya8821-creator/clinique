export const adminStats = [
  { label: "Rendez-vous aujourd'hui", value: "8", icon: "bi-calendar-check", href: "/dashboard/appointments", tone: "primary" },
  { label: "Messages non lus", value: "5", icon: "bi-envelope-exclamation", href: "/dashboard/messages", tone: "warning" },
  { label: "Pages publiees", value: "16", icon: "bi-file-earmark-text", href: "/dashboard/content/pages", tone: "success" },
  { label: "Medias", value: "42", icon: "bi-images", href: "/dashboard/media", tone: "neutral" },
];

export const sampleMessages = [
  { name: "Patient Demo", email: "patient@example.com", subject: "Rendez-vous", message: "Je souhaite plus d'informations.", date: "2026-09-23", status: "Non lu" },
  { name: "Famille Yetu", email: "contact@example.com", subject: "Services", message: "Question sur la pediatrie.", date: "2026-09-22", status: "Lu" },
];

export const sampleAppointments = [
  { name: "Patient Demo", email: "patient@example.com", phone: "+243 970 220 803", date: "2026-09-25", time: "10:30", department: "Pediatrie", doctor: "A assigner", message: "Consultation generale", status: "En attente" },
  { name: "Grace M.", email: "grace@example.com", phone: "+243 000 000 000", date: "2026-09-26", time: "14:00", department: "Gynecologie", doctor: "A assigner", message: "Controle", status: "Confirme" },
];

export const sampleMedia = [
  { name: "staff-10.webp", path: "/assets/img/health/staff-10.webp", mime: "image/webp" },
  { name: "facilities-9.webp", path: "/assets/img/health/facilities-9.webp", mime: "image/webp" },
  { name: "logos.webp", path: "/assets/img/logos.webp", mime: "image/webp" },
];

export const cmsSections = [
  { label: "Hero principal", title: "Excellence en Soins de sante", image: "assets/img/health/staff-10.webp" },
  { label: "Bloc presentation", title: "Soins Bienveillants", image: "assets/img/health/facilities-9.webp" },
  { label: "Appel a l'action", title: "L'excellence dans les soins, quotidien", image: "assets/img/health/facilities-9.webp" },
];

export const pageSlugs = ["index", "about", "services", "service-details", "contact", "404"];

export const quickActions = [
  { href: "/dashboard/content/home", label: "Modifier l'accueil", icon: "bi-pencil-square" },
  { href: "/dashboard/appointments", label: "Voir les rendez-vous", icon: "bi-calendar-check" },
  { href: "/dashboard/messages", label: "Lire les messages", icon: "bi-envelope-open" },
  { href: "/dashboard/media", label: "Ajouter un media", icon: "bi-cloud-arrow-up" },
];

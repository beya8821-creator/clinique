export type CmsPage = {
  id: number;
  title: string;
  slug: string;
  template_file: string | null;
  html_content: string | null;
  is_active: boolean;
  created_at: string;
  updated_at: string;
};

export type CmsSection = {
  id: number;
  page_slug: string;
  section_key: string;
  label: string;
  title: string | null;
  subtitle: string | null;
  body: string | null;
  button_text: string | null;
  button_url: string | null;
  image_path: string | null;
  video_url: string | null;
  extra_json: Record<string, unknown> | null;
  created_at: string;
  updated_at: string;
};

export type CmsService = {
  id: number;
  title: string;
  slug: string;
  description: string;
  image_path: string;
  icon_class: string;
  button_text: string | null;
  button_url: string | null;
  features_text: string | null;
  sort_order: number;
  is_active: boolean;
  created_at: string;
  updated_at: string;
};

export type HeroSlide = {
  id: number;
  image: string;
  title: string | null;
  subtitle: string | null;
  button_text: string | null;
  button_link: string | null;
  display_order: number;
  status: boolean;
  created_at: string;
  updated_at: string;
};

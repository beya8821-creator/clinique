import type { Profile } from "@/types/auth";
import type { CmsPage, CmsSection, CmsService, HeroSlide } from "@/types/cms";

export type ContactMessage = {
  id: number;
  name: string;
  email: string;
  subject: string | null;
  message: string;
  ip_address: string | null;
  user_agent: string | null;
  is_read: boolean;
  created_at: string;
};

export type Appointment = {
  id: number;
  name: string;
  email: string;
  phone: string;
  appointment_date: string | null;
  appointment_time: string | null;
  appointment_date_raw: string | null;
  appointment_time_raw: string | null;
  department: string | null;
  doctor: string | null;
  message: string | null;
  status: "new" | "reviewed" | "confirmed" | "cancelled" | "archived";
  ip_address: string | null;
  created_at: string;
  updated_at: string;
};

export type MediaLibraryItem = {
  id: number;
  filename: string;
  original_name: string;
  path: string;
  storage_bucket: string;
  storage_object_path: string | null;
  mime_type: string;
  size_bytes: number;
  alt_text: string | null;
  uploaded_by: string | null;
  is_public: boolean;
  created_at: string;
};

export type Database = {
  public: {
    Tables: {
      profiles: TableDefinition<Profile>;
      pages: TableDefinition<CmsPage>;
      cms_sections: TableDefinition<CmsSection>;
      cms_services: TableDefinition<CmsService>;
      hero_slider: TableDefinition<HeroSlide>;
      contact_messages: TableDefinition<ContactMessage>;
      appointments: TableDefinition<Appointment>;
      media_library: TableDefinition<MediaLibraryItem>;
    };
    Views: Record<string, never>;
    Functions: Record<string, never>;
    Enums: {
      app_role: "admin" | "editor";
    };
    CompositeTypes: Record<string, never>;
  };
};

type TableDefinition<Row> = {
  Row: Row;
  Insert: Partial<Row>;
  Update: Partial<Row>;
};

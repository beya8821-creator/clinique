import { hasPublicSupabaseEnv } from "@/lib/config/env";
import { createSupabaseServerClient } from "@/lib/supabase/server";
import type { Appointment, ContactMessage } from "@/types/database";

import { sampleAppointments, sampleMessages } from "@/components/dashboard/admin-data";

export type AdminMessageRow = {
  id: string;
  name: string;
  email: string;
  subject: string;
  message: string;
  date: string;
  status: string;
};

export type AdminAppointmentRow = {
  id: string;
  name: string;
  email: string;
  phone: string;
  date: string;
  time: string;
  department: string;
  doctor: string;
  status: string;
};

function formatDate(value: string | null | undefined) {
  if (!value) return "-";
  return new Intl.DateTimeFormat("fr-FR", { dateStyle: "medium" }).format(new Date(value));
}

function formatStatus(value: string) {
  return {
    new: "Nouveau",
    reviewed: "Traité",
    confirmed: "Confirmé",
    cancelled: "Annulé",
    archived: "Archivé",
  }[value] ?? value;
}

export async function getAdminMessages(): Promise<AdminMessageRow[]> {
  if (!hasPublicSupabaseEnv()) {
    return sampleMessages.map((row, index) => ({ ...row, id: `sample-message-${index}` }));
  }

  try {
    const supabase = await createSupabaseServerClient();
    const { data, error } = await supabase
      .from("contact_messages")
      .select("*")
      .order("created_at", { ascending: false });

    if (error || !data) throw error ?? new Error("Messages indisponibles");

    return (data as unknown as ContactMessage[]).map((row) => ({
      id: String(row.id),
      name: row.name,
      email: row.email,
      subject: row.subject ?? "Sans sujet",
      message: row.message,
      date: formatDate(row.created_at),
      status: row.is_read ? "Lu" : "Non lu",
    }));
  } catch {
    return sampleMessages.map((row, index) => ({ ...row, id: `sample-message-${index}` }));
  }
}

export async function getAdminAppointments(): Promise<AdminAppointmentRow[]> {
  if (!hasPublicSupabaseEnv()) {
    return sampleAppointments.map((row, index) => ({ ...row, id: `sample-appointment-${index}` }));
  }

  try {
    const supabase = await createSupabaseServerClient();
    const { data, error } = await supabase
      .from("appointments")
      .select("*")
      .order("created_at", { ascending: false });

    if (error || !data) throw error ?? new Error("Rendez-vous indisponibles");

    return (data as unknown as Appointment[]).map((row) => ({
      id: String(row.id),
      name: row.name,
      email: row.email,
      phone: row.phone,
      date: row.appointment_date ? formatDate(row.appointment_date) : row.appointment_date_raw ?? "-",
      time: row.appointment_time?.slice(0, 5) ?? row.appointment_time_raw ?? "-",
      department: row.department ?? "-",
      doctor: row.doctor ?? "À assigner",
      status: formatStatus(row.status),
    }));
  } catch {
    return sampleAppointments.map((row, index) => ({ ...row, id: `sample-appointment-${index}` }));
  }
}

"use server";

import { headers } from "next/headers";
import { redirect } from "next/navigation";

import { env, hasPublicSupabaseEnv } from "@/lib/config/env";
import { createSupabaseAdminClient } from "@/lib/supabase/admin";
import { createSupabaseServerClient } from "@/lib/supabase/server";
import { appointmentSchema, contactMessageSchema } from "@/lib/validations/contact";

function hasFormSupabaseEnv() {
  return hasPublicSupabaseEnv();
}

async function getFormClient() {
  return env.supabaseServiceRoleKey ? createSupabaseAdminClient() : await createSupabaseServerClient();
}

async function getRequestMetadata() {
  const headerStore = await headers();
  const forwardedFor = headerStore.get("x-forwarded-for");
  const ipAddress = forwardedFor?.split(",")[0]?.trim() || headerStore.get("x-real-ip");

  return {
    ipAddress,
    userAgent: headerStore.get("user-agent"),
  };
}

export async function createContactMessageAction(formData: FormData) {
  const parsed = contactMessageSchema.safeParse({
    email: formData.get("email"),
    message: formData.get("message"),
    name: formData.get("name"),
    subject: formData.get("subject"),
    website: formData.get("website"),
  });

  if (!parsed.success) {
    redirect("/contact?status=invalid");
  }

  if (!hasFormSupabaseEnv()) {
    redirect("/contact?status=supabase-missing");
  }

  const supabase = await getFormClient();
  const metadata = await getRequestMetadata();
  const { error } = await supabase.from("contact_messages").insert({
    email: parsed.data.email,
    ip_address: metadata.ipAddress,
    message: parsed.data.message,
    name: parsed.data.name,
    subject: parsed.data.subject,
    user_agent: metadata.userAgent,
  } as never);

  if (error) {
    redirect("/contact?status=error");
  }

  redirect("/contact?status=sent");
}

export async function createAppointmentAction(formData: FormData) {
  const parsed = appointmentSchema.safeParse({
    appointmentDate: formData.get("appointmentDate"),
    appointmentTime: formData.get("appointmentTime"),
    department: formData.get("department"),
    doctor: formData.get("doctor"),
    email: formData.get("email"),
    message: formData.get("message"),
    name: formData.get("name"),
    phone: formData.get("phone"),
  });

  if (!parsed.success) {
    redirect("/appointment?status=invalid");
  }

  if (!hasFormSupabaseEnv()) {
    redirect("/appointment?status=supabase-missing");
  }

  const supabase = await getFormClient();
  const metadata = await getRequestMetadata();
  const { error } = await supabase.from("appointments").insert({
    appointment_date: parsed.data.appointmentDate || null,
    appointment_date_raw: parsed.data.appointmentDate || null,
    appointment_time: parsed.data.appointmentTime || null,
    appointment_time_raw: parsed.data.appointmentTime || null,
    department: parsed.data.department || null,
    doctor: parsed.data.doctor || null,
    email: parsed.data.email,
    ip_address: metadata.ipAddress,
    message: parsed.data.message || null,
    name: parsed.data.name,
    phone: parsed.data.phone,
    status: "new",
  } as never);

  if (error) {
    redirect("/appointment?status=error");
  }

  redirect("/appointment?status=sent");
}



"use server";

import { redirect } from "next/navigation";

import { hasPublicSupabaseEnv } from "@/lib/config/env";
import { createSupabaseServerClient } from "@/lib/supabase/server";

function normalizeNextPath(value: FormDataEntryValue | null) {
  const nextPath = typeof value === "string" && value.startsWith("/") ? value : "/dashboard";

  return nextPath.startsWith("/login") || nextPath.startsWith("/logout") ? "/dashboard" : nextPath;
}

export async function signInAction(formData: FormData) {
  const nextPath = normalizeNextPath(formData.get("next"));

  if (!hasPublicSupabaseEnv()) {
    redirect(`/login?status=supabase-missing&next=${encodeURIComponent(nextPath)}`);
  }

  const email = String(formData.get("email") ?? "").trim();
  const password = String(formData.get("password") ?? "");

  if (!email || !password) {
    redirect(`/login?status=invalid&next=${encodeURIComponent(nextPath)}`);
  }

  const supabase = await createSupabaseServerClient();
  const { error } = await supabase.auth.signInWithPassword({
    email,
    password,
  });

  if (error) {
    redirect(`/login?status=error&next=${encodeURIComponent(nextPath)}`);
  }

  redirect(nextPath);
}

export async function signOutAction() {
  if (hasPublicSupabaseEnv()) {
    const supabase = await createSupabaseServerClient();
    await supabase.auth.signOut();
  }

  redirect("/login?status=signed-out");
}

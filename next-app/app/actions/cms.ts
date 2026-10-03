"use server";

import { revalidatePath } from "next/cache";

import { env, hasPublicSupabaseEnv } from "@/lib/config/env";
import { createSupabaseAdminClient } from "@/lib/supabase/admin";
import { createSupabaseServerClient } from "@/lib/supabase/server";
import type { CmsSection } from "@/types/cms";

type CmsActionResult = {
  error?: string;
  ok: boolean;
};

type HeroSlideInput = {
  button_link?: string | null;
  button_text?: string | null;
  display_order: number;
  id?: number;
  image: string;
  status: boolean;
  subtitle?: string | null;
  title?: string | null;
};

type CmsSectionInput = Pick<
  CmsSection,
  | "body"
  | "button_text"
  | "button_url"
  | "extra_json"
  | "image_path"
  | "label"
  | "page_slug"
  | "section_key"
  | "subtitle"
  | "title"
  | "video_url"
> & {
  id?: number;
};

function hasCmsSupabaseEnv() {
  return hasPublicSupabaseEnv();
}

async function getCmsClient() {
  return env.supabaseServiceRoleKey ? createSupabaseAdminClient() : await createSupabaseServerClient();
}

function missingEnvResult(): CmsActionResult {
  return {
    error: "Supabase n'est pas encore configure. Ajoutez les variables Supabase dans .env.local et connectez-vous comme administrateur.",
    ok: false,
  };
}

export async function upsertHeroSlideAction(input: HeroSlideInput): Promise<CmsActionResult> {
  if (!hasCmsSupabaseEnv()) {
    return missingEnvResult();
  }

  const supabase = await getCmsClient();
  const payload = {
    button_link: input.button_link ?? null,
    button_text: input.button_text ?? null,
    display_order: input.display_order,
    image: input.image,
    status: input.status,
    subtitle: input.subtitle ?? null,
    title: input.title ?? null,
  };

  const query = input.id
    ? supabase.from("hero_slider").update(payload as never).eq("id", input.id)
    : supabase.from("hero_slider").insert(payload as never);
  const { error } = await query;

  if (error) {
    return { error: error.message, ok: false };
  }

  revalidatePath("/");
  revalidatePath("/dashboard/content/hero-slider");

  return { ok: true };
}

export async function deleteHeroSlideAction(id: number): Promise<CmsActionResult> {
  if (!hasCmsSupabaseEnv()) {
    return missingEnvResult();
  }

  const supabase = await getCmsClient();
  const { error } = await supabase.from("hero_slider").delete().eq("id", id);

  if (error) {
    return { error: error.message, ok: false };
  }

  revalidatePath("/");
  revalidatePath("/dashboard/content/hero-slider");

  return { ok: true };
}

export async function upsertCmsSectionAction(input: CmsSectionInput): Promise<CmsActionResult> {
  if (!hasCmsSupabaseEnv()) {
    return missingEnvResult();
  }

  const supabase = await getCmsClient();
  const payload = {
    body: input.body,
    button_text: input.button_text,
    button_url: input.button_url,
    extra_json: input.extra_json,
    image_path: input.image_path,
    label: input.label,
    page_slug: input.page_slug,
    section_key: input.section_key,
    subtitle: input.subtitle,
    title: input.title,
    video_url: input.video_url,
  };

  const query = input.id
    ? supabase.from("cms_sections").update(payload as never).eq("id", input.id)
    : supabase.from("cms_sections").upsert(payload as never, { onConflict: "page_slug,section_key" });
  const { error } = await query;

  if (error) {
    return { error: error.message, ok: false };
  }

  revalidatePath("/");
  revalidatePath(`/${input.page_slug === "home" ? "" : input.page_slug}`);
  revalidatePath(`/dashboard/content/${input.page_slug}`);

  return { ok: true };
}

export async function deleteCmsSectionAction(id: number, pageSlug: string): Promise<CmsActionResult> {
  if (!hasCmsSupabaseEnv()) {
    return missingEnvResult();
  }

  const supabase = await getCmsClient();
  const { error } = await supabase.from("cms_sections").delete().eq("id", id);

  if (error) {
    return { error: error.message, ok: false };
  }

  revalidatePath("/");
  revalidatePath(`/${pageSlug === "home" ? "" : pageSlug}`);
  revalidatePath(`/dashboard/content/${pageSlug}`);

  return { ok: true };
}



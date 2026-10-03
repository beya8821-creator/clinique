import "server-only";

import { createClient } from "@supabase/supabase-js";

import { env } from "@/lib/config/env";
import type { Database } from "@/types/database";

export function createSupabaseAdminClient() {
  if (!env.supabaseUrl || !env.supabaseServiceRoleKey) {
    throw new Error("Supabase server environment variables are not configured.");
  }

  return createClient<Database>(env.supabaseUrl, env.supabaseServiceRoleKey, {
    auth: {
      autoRefreshToken: false,
      persistSession: false,
    },
  });
}

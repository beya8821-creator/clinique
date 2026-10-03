import { createBrowserClient } from "@supabase/ssr";

import { env } from "@/lib/config/env";
import type { Database } from "@/types/database";

export function createSupabaseBrowserClient() {
  if (!env.supabaseUrl || !env.supabaseAnonKey) {
    throw new Error("Supabase public environment variables are not configured.");
  }

  return createBrowserClient<Database>(env.supabaseUrl, env.supabaseAnonKey);
}

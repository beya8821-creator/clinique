export type AppRole = "admin" | "editor";
export type ProfileStatus = "active" | "disabled";

export type Profile = {
  id: string;
  legacy_user_id: number | null;
  name: string;
  email: string;
  role: AppRole;
  status: ProfileStatus;
  created_at: string;
  updated_at: string;
};

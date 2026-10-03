import { MediaManager } from "@/components/dashboard/AdminForms";
import { AdminShell } from "@/components/dashboard/AdminShell";

export default function MediaPage() {
  return (
    <AdminShell activePath="/dashboard/media" title="Media">
      <MediaManager />
    </AdminShell>
  );
}

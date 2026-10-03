import { AdminShell } from "@/components/dashboard/AdminShell";
import { MessagesTable } from "@/components/dashboard/AdminTables";
import { getAdminMessages } from "@/lib/cms/admin-content";

export default async function MessagesPage() {
  const rows = await getAdminMessages();

  return (
    <AdminShell activePath="/dashboard/messages" title="Messages">
      <MessagesTable rows={rows} />
    </AdminShell>
  );
}

import { AdminShell } from "@/components/dashboard/AdminShell";
import { AppointmentsTable } from "@/components/dashboard/AdminTables";
import { getAdminAppointments } from "@/lib/cms/admin-content";

export default async function AppointmentsPage() {
  const rows = await getAdminAppointments();

  return (
    <AdminShell activePath="/dashboard/appointments" title="Appointments">
      <AppointmentsTable rows={rows} />
    </AdminShell>
  );
}

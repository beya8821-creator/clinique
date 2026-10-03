import { AdminShell } from "@/components/dashboard/AdminShell";

export default function ActivityPage() {
  return (
    <AdminShell activePath="/dashboard/activity" title="Activity logs">
      <div className="admin-table-wrap">
        <table className="admin-table">
          <thead>
            <tr>
              <th>User</th>
              <th>Action</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Administrator</td>
              <td>CMS admin migrated to Next.js UI placeholder</td>
              <td>2026-09-23</td>
            </tr>
          </tbody>
        </table>
      </div>
    </AdminShell>
  );
}

import { AdminShell } from "@/components/dashboard/AdminShell";

export default function NewsletterPage() {
  return (
    <AdminShell activePath="/dashboard/newsletter" title="Newsletter">
      <div className="admin-table-wrap">
        <table className="admin-table">
          <thead>
            <tr>
              <th>Email</th>
              <th>Subscribed at</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>subscriber@example.com</td>
              <td>2026-09-23</td>
            </tr>
          </tbody>
        </table>
      </div>
    </AdminShell>
  );
}

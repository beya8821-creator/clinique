import type { AdminAppointmentRow, AdminMessageRow } from "@/lib/cms/admin-content";

export function MessagesTable({ rows }: { rows: AdminMessageRow[] }) {
  return (
    <section className="admin-stack">
      <div className="admin-filter-bar" aria-label="Filtres messages">
        <button type="button" className="active">Non lus</button>
        <button type="button">Lus</button>
        <button type="button">Archives</button>
      </div>
      <div className="admin-table-wrap">
        <table className="admin-table">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Email</th>
              <th>Sujet</th>
              <th>Message</th>
              <th>Date</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {rows.map((row) => (
              <tr key={row.id}>
                <td>{row.name}</td>
                <td>{row.email}</td>
                <td>{row.subject}</td>
                <td>{row.message}</td>
                <td>{row.date}</td>
                <td><span className="admin-badge">{row.status}</span></td>
                <td><button type="button" className="admin-table-action">Ouvrir</button></td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </section>
  );
}

export function AppointmentsTable({ rows }: { rows: AdminAppointmentRow[] }) {
  return (
    <section className="admin-stack">
      <div className="admin-filter-bar" aria-label="Filtres rendez-vous">
        <button type="button" className="active">Aujourd&apos;hui</button>
        <button type="button">Cette semaine</button>
        <button type="button">En attente</button>
        <button type="button">Confirmes</button>
        <button type="button">Traites</button>
      </div>
      <div className="admin-table-wrap">
        <table className="admin-table">
          <thead>
            <tr>
              <th>Patient</th>
              <th>Email</th>
              <th>Telephone</th>
              <th>Date</th>
              <th>Heure</th>
              <th>Service</th>
              <th>Medecin</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {rows.map((row) => (
              <tr key={row.id}>
                <td>{row.name}</td>
                <td>{row.email}</td>
                <td>{row.phone}</td>
                <td>{row.date}</td>
                <td>{row.time}</td>
                <td>{row.department}</td>
                <td>{row.doctor}</td>
                <td><span className="admin-badge">{row.status}</span></td>
                <td><button type="button" className="admin-table-action">Voir detail</button></td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </section>
  );
}

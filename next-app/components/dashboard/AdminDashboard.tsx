import Link from "next/link";

import { adminStats, quickActions, sampleAppointments, sampleMessages } from "./admin-data";

export function AdminDashboard() {
  return (
    <div className="admin-stack">
      <section className="admin-hero">
        <div>
          <p className="admin-kicker">Aujourd&apos;hui</p>
          <h2>Bonjour, Administrateur</h2>
          <p>Voici ce qui demande votre attention dans le site de la Polyclinique Yetu.</p>
        </div>
        <Link href="/dashboard/content/home" className="admin-primary-action">
          Modifier l&apos;accueil
        </Link>
      </section>

      <section className="admin-stat-grid" aria-label="Indicateurs principaux">
        {adminStats.map((stat) => (
          <Link className={`admin-stat-card ${stat.tone}`} href={stat.href} key={stat.label}>
            <i className={`bi ${stat.icon}`} aria-hidden="true" />
            <span>{stat.label}</span>
            <strong>{stat.value}</strong>
          </Link>
        ))}
      </section>

      <div className="admin-dashboard-grid">
        <section className="admin-panel">
          <div className="admin-panel-header">
            <h2>Rendez-vous recents</h2>
            <Link href="/dashboard/appointments">Voir tout</Link>
          </div>
          <div className="admin-list">
            {sampleAppointments.map((item) => (
              <article className="admin-list-item" key={`${item.email}-${item.date}`}>
                <div>
                  <strong>{item.name}</strong>
                  <span>
                    {item.department} - {item.date} a {item.time}
                  </span>
                </div>
                <span className="admin-badge">{item.status}</span>
              </article>
            ))}
          </div>
        </section>

        <section className="admin-panel">
          <div className="admin-panel-header">
            <h2>Messages recents</h2>
            <Link href="/dashboard/messages">Voir tout</Link>
          </div>
          <div className="admin-list">
            {sampleMessages.map((item) => (
              <article className="admin-list-item" key={`${item.email}-${item.date}`}>
                <div>
                  <strong>{item.subject}</strong>
                  <span>
                    {item.name} - {item.date}
                  </span>
                </div>
                <span className="admin-badge">{item.status}</span>
              </article>
            ))}
          </div>
        </section>
      </div>

      <section className="admin-panel">
        <div className="admin-panel-header">
          <h2>Actions rapides</h2>
        </div>
        <div className="admin-actions">
          {quickActions.map((action) => (
            <Link href={action.href} key={action.href}>
              <i className={`bi ${action.icon}`} aria-hidden="true" />
              <span>{action.label}</span>
            </Link>
          ))}
        </div>
      </section>
    </div>
  );
}

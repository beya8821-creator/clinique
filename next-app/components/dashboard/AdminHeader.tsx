"use client";

import Link from "next/link";
import { useEffect, useState } from "react";

import { signOutAction } from "@/app/actions/auth";

type AdminHeaderProps = {
  isMobileSidebarOpen: boolean;
  isSidebarCollapsed: boolean;
  onToggleNavigation: () => void;
};

const notifications = [
  {
    title: "Nouveau rendez-vous",
    description: "Jean Mukendi",
    time: "Il y a 5 minutes",
    type: "appointment",
    unread: true,
  },
  {
    title: "Nouveau message",
    description: "Demande d'information",
    time: "Il y a 15 minutes",
    type: "message",
    unread: true,
  },
  {
    title: "Modification enregistree",
    description: "Page Accueil",
    time: "Il y a 1 heure",
    type: "content",
    unread: false,
  },
];

const searchResults = [
  { group: "Rendez-vous", title: "Jean Mukendi", subtitle: "Rendez-vous - 23 septembre 2026", icon: "bi-calendar-check" },
  { group: "Messages", title: "Demande d'information", subtitle: "Message de contact", icon: "bi-envelope" },
  { group: "Pages", title: "Services", subtitle: "Contenu du site", icon: "bi-file-earmark-text" },
];

export function AdminHeader({
  isSidebarCollapsed,
  isMobileSidebarOpen,
  onToggleNavigation,
}: AdminHeaderProps) {
  const [isSearchOpen, setIsSearchOpen] = useState(false);
  const [isNotificationsOpen, setIsNotificationsOpen] = useState(false);
  const [isUserMenuOpen, setIsUserMenuOpen] = useState(false);

  useEffect(() => {
    function onKeyDown(event: KeyboardEvent) {
      if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === "k") {
        event.preventDefault();
        setIsSearchOpen(true);
      }

      if (event.key === "Escape") {
        setIsSearchOpen(false);
        setIsNotificationsOpen(false);
        setIsUserMenuOpen(false);
      }
    }

    window.addEventListener("keydown", onKeyDown);
    return () => window.removeEventListener("keydown", onKeyDown);
  }, []);

  const unreadCount = notifications.filter((item) => item.unread).length;

  return (
    <header className="admin-header">
      <div className="admin-header-left">
        <button
          type="button"
          className="admin-icon-button"
          aria-label={isMobileSidebarOpen ? "Fermer le menu" : "Ouvrir le menu"}
          aria-pressed={isSidebarCollapsed}
          onClick={onToggleNavigation}
        >
          <i className="bi bi-list" aria-hidden="true" />
        </button>
        <span className="admin-header-mobile-brand">Polyclinique Yetu</span>
      </div>

      <div className="admin-header-center">
        <button type="button" className="admin-global-search" onClick={() => setIsSearchOpen(true)}>
          <i className="bi bi-search" aria-hidden="true" />
          <span>Rechercher dans l&apos;administration...</span>
          <kbd>Ctrl K</kbd>
        </button>
      </div>

      <div className="admin-header-right">
        <Link href="/" target="_blank" className="admin-public-link">
          <span>Voir le site</span>
          <i className="bi bi-arrow-up-right" aria-hidden="true" />
        </Link>

        <div className="admin-menu-wrap">
          <button
            type="button"
            className="admin-icon-button"
            aria-label="Voir les notifications"
            aria-expanded={isNotificationsOpen}
            onClick={() => {
              setIsNotificationsOpen((value) => !value);
              setIsUserMenuOpen(false);
            }}
          >
            <i className="bi bi-bell" aria-hidden="true" />
            <span className="admin-notification-badge">{unreadCount}</span>
          </button>

          {isNotificationsOpen ? (
            <div className="admin-dropdown admin-notification-dropdown">
              <div className="admin-dropdown-heading">
                <strong>Notifications</strong>
              </div>
              {notifications.map((item) => (
                <article className="admin-notification-item" key={`${item.type}-${item.time}`}>
                  <span className={item.unread ? "unread" : ""} aria-hidden="true" />
                  <div>
                    <strong>{item.title}</strong>
                    <p>{item.description}</p>
                    <small>{item.time}</small>
                  </div>
                </article>
              ))}
              <Link href="/dashboard/activity" className="admin-dropdown-footer">
                Voir toutes les notifications
                <i className="bi bi-arrow-right" aria-hidden="true" />
              </Link>
            </div>
          ) : null}
        </div>

        <div className="admin-menu-wrap">
          <button
            type="button"
            className="admin-user-trigger"
            aria-label="Ouvrir le menu utilisateur"
            aria-expanded={isUserMenuOpen}
            onClick={() => {
              setIsUserMenuOpen((value) => !value);
              setIsNotificationsOpen(false);
            }}
          >
            <span className="admin-avatar">AB</span>
            <span className="admin-user-label">
              <strong>Administrateur</strong>
              <small>Gestion complete</small>
            </span>
            <i className="bi bi-chevron-down" aria-hidden="true" />
          </button>

          {isUserMenuOpen ? (
            <div className="admin-dropdown admin-user-dropdown">
              <div className="admin-user-summary">
                <span className="admin-avatar large">AB</span>
                <div>
                  <strong>Administrateur</strong>
                  <p>admin@polycliniqueyetu.cd</p>
                </div>
              </div>
              <Link href="/dashboard/users">
                <i className="bi bi-person" aria-hidden="true" />
                Mon profil
              </Link>
              <Link href="/dashboard/settings">
                <i className="bi bi-sliders" aria-hidden="true" />
                Parametres
              </Link>
              <Link href="/" target="_blank">
                <i className="bi bi-arrow-up-right" aria-hidden="true" />
                Voir le site
              </Link>
              <form action={signOutAction}>
                <button type="submit" className="admin-dropdown-logout danger">
                  <i className="bi bi-box-arrow-right" aria-hidden="true" />
                  Se déconnecter
                </button>
              </form>
            </div>
          ) : null}
        </div>
      </div>

      {isSearchOpen ? (
        <div className="admin-search-overlay" role="dialog" aria-modal="true" aria-label="Recherche globale">
          <div className="admin-search-panel">
            <div className="admin-search-input-row">
              <button type="button" aria-label="Fermer la recherche" onClick={() => setIsSearchOpen(false)}>
                <i className="bi bi-arrow-left" aria-hidden="true" />
              </button>
              <i className="bi bi-search" aria-hidden="true" />
              <input autoFocus placeholder="Rechercher..." />
            </div>
            <div className="admin-search-results">
              <p>Resultats</p>
              {searchResults.map((result) => (
                <Link href="/dashboard" key={`${result.group}-${result.title}`} onClick={() => setIsSearchOpen(false)}>
                  <i className={`bi ${result.icon}`} aria-hidden="true" />
                  <span>
                    <small>{result.group}</small>
                    <strong>{result.title}</strong>
                    <em>{result.subtitle}</em>
                  </span>
                </Link>
              ))}
            </div>
          </div>
        </div>
      ) : null}
    </header>
  );
}

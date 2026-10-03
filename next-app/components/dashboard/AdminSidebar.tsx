"use client";

import Link from "next/link";

import { adminNavigation, type AdminNavigationItem, type AdminNavigationSection } from "./navigation";

type AdminSidebarProps = {
  activePath: string;
  isCollapsed: boolean;
  isMobileOpen: boolean;
  onCloseMobile: () => void;
};

function isActiveRoute(activePath: string, href: string) {
  if (href === "/dashboard") {
    return activePath === href;
  }

  return activePath === href || activePath.startsWith(`${href}/`);
}

function SidebarHeader() {
  return (
    <Link href="/dashboard" className="admin-sidebar-brand">
      <img src="/assets/img/logos.webp" alt="" />
      <span>
        <strong>Polyclinique Yetu</strong>
        <small>Administration</small>
      </span>
    </Link>
  );
}

function SidebarItem({
  activePath,
  item,
  onCloseMobile,
}: {
  activePath: string;
  item: AdminNavigationItem;
  onCloseMobile: () => void;
}) {
  const active = isActiveRoute(activePath, item.href);
  const hasChildren = Boolean(item.children?.length);

  return (
    <div className={["admin-sidebar-item-group", active ? "active" : ""].filter(Boolean).join(" ")}>
      <Link
        aria-current={active && !hasChildren ? "page" : undefined}
        className={["admin-sidebar-link", active ? "active" : ""].filter(Boolean).join(" ")}
        href={item.href}
        onClick={onCloseMobile}
        title={item.label}
      >
        <i className={`bi ${item.icon}`} aria-hidden="true" />
        <span className="admin-sidebar-label">{item.label}</span>
        {item.badge ? <span className="admin-sidebar-badge">{item.badge}</span> : null}
        {hasChildren ? <i className="bi bi-chevron-down admin-sidebar-chevron" aria-hidden="true" /> : null}
      </Link>
      {hasChildren ? (
        <div className="admin-sidebar-submenu">
          {item.children?.map((child) => {
            const childActive = isActiveRoute(activePath, child.href);

            return (
              <Link
                aria-current={childActive ? "page" : undefined}
                className={["admin-sidebar-sublink", childActive ? "active" : ""].filter(Boolean).join(" ")}
                href={child.href}
                key={child.id}
                onClick={onCloseMobile}
              >
                {child.label}
              </Link>
            );
          })}
        </div>
      ) : null}
    </div>
  );
}

function SidebarSection({
  activePath,
  onCloseMobile,
  section,
}: {
  activePath: string;
  onCloseMobile: () => void;
  section: AdminNavigationSection;
}) {
  return (
    <div className="admin-sidebar-group">
      <span className="admin-sidebar-section">{section.label}</span>
      {section.items.map((item) => (
        <SidebarItem activePath={activePath} item={item} key={item.id} onCloseMobile={onCloseMobile} />
      ))}
    </div>
  );
}

function SidebarNavigation({
  activePath,
  onCloseMobile,
}: {
  activePath: string;
  onCloseMobile: () => void;
}) {
  return (
    <nav className="admin-sidebar-navigation" aria-label="Navigation principale de l'administration">
      {adminNavigation.map((section) => (
        <SidebarSection
          activePath={activePath}
          key={section.id}
          onCloseMobile={onCloseMobile}
          section={section}
        />
      ))}
    </nav>
  );
}

function SidebarFooter({ onCloseMobile }: { onCloseMobile: () => void }) {
  return (
    <footer className="admin-sidebar-footer">
      <Link href="/" onClick={onCloseMobile} target="_blank">
        <i className="bi bi-arrow-up-right" aria-hidden="true" />
        <span>Voir le site</span>
      </Link>
      <small>Administration v1.0</small>
    </footer>
  );
}

export function AdminSidebar({ activePath, isCollapsed, isMobileOpen, onCloseMobile }: AdminSidebarProps) {
  return (
    <>
      <aside
        aria-label="Navigation admin Polyclinique Yetu"
        className={[
          "admin-sidebar",
          isCollapsed ? "is-collapsed" : "",
          isMobileOpen ? "is-mobile-open" : "",
        ]
          .filter(Boolean)
          .join(" ")}
      >
        <button className="admin-sidebar-close" onClick={onCloseMobile} type="button">
          <i className="bi bi-x-lg" aria-hidden="true" />
          <span>Fermer le menu</span>
        </button>
        <SidebarHeader />
        <SidebarNavigation activePath={activePath} onCloseMobile={onCloseMobile} />
        <SidebarFooter onCloseMobile={onCloseMobile} />
      </aside>
      {isMobileOpen ? (
        <button
          aria-label="Fermer le menu"
          className="admin-sidebar-overlay"
          onClick={onCloseMobile}
          type="button"
        />
      ) : null}
    </>
  );
}

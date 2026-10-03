"use client";

import { ReactNode } from "react";
import { useEffect, useState } from "react";

import { AdminHeader } from "./AdminHeader";
import { AdminSidebar } from "./AdminSidebar";

type AdminShellProps = {
  activePath: string;
  children: ReactNode;
  title: string;
};

export function AdminShell({ activePath, children, title }: AdminShellProps) {
  const [isSidebarCollapsed, setIsSidebarCollapsed] = useState(() => {
    if (typeof window === "undefined") {
      return false;
    }

    return window.localStorage.getItem("polyclinique-yetu-sidebar-collapsed") === "true";
  });
  const [isMobileSidebarOpen, setIsMobileSidebarOpen] = useState(false);

  useEffect(() => {
    window.localStorage.setItem("polyclinique-yetu-sidebar-collapsed", String(isSidebarCollapsed));
  }, [isSidebarCollapsed]);

  useEffect(() => {
    function onKeyDown(event: KeyboardEvent) {
      if (event.key === "Escape") {
        setIsMobileSidebarOpen(false);
      }
    }

    window.addEventListener("keydown", onKeyDown);
    return () => window.removeEventListener("keydown", onKeyDown);
  }, []);

  function toggleNavigation() {
    if (window.matchMedia("(max-width: 980px)").matches) {
      setIsMobileSidebarOpen((value) => !value);
      return;
    }

    setIsSidebarCollapsed((value) => !value);
  }

  return (
    <div
      className={[
        "admin-app",
        isSidebarCollapsed ? "admin-sidebar-collapsed" : "",
        isMobileSidebarOpen ? "admin-sidebar-mobile-open" : "",
      ]
        .filter(Boolean)
        .join(" ")}
    >
      <AdminHeader
        isMobileSidebarOpen={isMobileSidebarOpen}
        isSidebarCollapsed={isSidebarCollapsed}
        onToggleNavigation={toggleNavigation}
      />

      <div className="admin-layout">
        <AdminSidebar
          activePath={activePath}
          isCollapsed={isSidebarCollapsed}
          isMobileOpen={isMobileSidebarOpen}
          onCloseMobile={() => setIsMobileSidebarOpen(false)}
        />

        <main className="admin-main">
          <section className="admin-page-heading">
            <p>Back-office Polyclinique Yetu</p>
            <h1>{title}</h1>
          </section>
          <section className="admin-card">
            {children}
          </section>
        </main>
      </div>
    </div>
  );
}

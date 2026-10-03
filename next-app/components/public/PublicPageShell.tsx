import { ReactNode } from "react";

import { BootstrapMadeRuntime } from "./BootstrapMadeRuntime";
import { PublicFooter } from "./PublicFooter";
import { PublicHeader } from "./PublicHeader";

type PublicPageShellProps = {
  activePath?: string;
  children: ReactNode;
};

export function PublicPageShell({ activePath = "/", children }: PublicPageShellProps) {
  return (
    <div className="public-site">
      <div id="preloader" aria-hidden="true" />
      <PublicHeader activePath={activePath} />
      {children}
      <BootstrapMadeRuntime />
      <a href="#!" id="scroll-top" className="scroll-top d-flex align-items-center justify-content-center">
        <i className="bi bi-arrow-up-short" aria-hidden="true" />
      </a>
      <PublicFooter />
    </div>
  );
}

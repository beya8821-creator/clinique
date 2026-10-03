import Link from "next/link";

const navLinks = [
  { href: "/", label: "Home" },
  { href: "/about", label: "About" },
  { href: "/services", label: "Services" },
  { href: "/contact", label: "Contact" },
];

type PublicHeaderProps = {
  activePath?: string;
};

export function PublicHeader({ activePath = "/" }: PublicHeaderProps) {
  return (
    <header id="header" className="header fixed-top">
      <div className="branding d-flex align-items-cente">
        <div className="container position-relative d-flex align-items-center justify-content-between">
          <Link href="/" className="logo d-flex align-items-center">
            <img src="/assets/img/logos.webp" alt="" />
            <h1 className="sitename">Polyclinique Yetu</h1>
          </Link>

          <nav id="navmenu" className="navmenu">
            <ul>
              {navLinks.map((link) => (
                <li key={link.href}>
                  <Link href={link.href} className={activePath === link.href ? "active" : undefined}>
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
            <i className="mobile-nav-toggle d-xl-none bi bi-list" aria-hidden="true" />
          </nav>
        </div>
      </div>
    </header>
  );
}

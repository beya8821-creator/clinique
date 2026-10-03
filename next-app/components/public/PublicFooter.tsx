import Link from "next/link";

export function PublicFooter() {
  return (
    <footer id="footer" className="footer-16 footer position-relative">
      <div className="container">
        <div className="footer-main" data-aos="fade-up" data-aos-delay="100">
          <div className="row align-items-start">
            <div className="col-lg-5">
              <div className="brand-section">
                <Link href="/" className="logo d-flex align-items-center mb-4">
                  <span className="sitename">Polyclinique Yetu</span>
                </Link>
                <p className="brand-description">
                  Crafting exceptional digital experiences through thoughtful design and innovative
                  solutions that elevate your brand presence.
                </p>

                <div className="contact-info mt-5">
                  <div className="contact-item">
                    <i className="bi bi-geo-alt" aria-hidden="true" />
                    <span>123 Creative Boulevard, Design District, NY 10012</span>
                  </div>
                  <div className="contact-item">
                    <i className="bi bi-telephone" aria-hidden="true" />
                    <span>+1 (555) 987-6543</span>
                  </div>
                  <div className="contact-item" />
                </div>
              </div>
            </div>

            <div className="col-lg-7">
              <div className="footer-nav-wrapper">
                <div className="row">
                  <div className="col-6 col-lg-3">
                    <div className="nav-column">
                      <i className="bi bi-envelope" aria-hidden="true" />
                      <span>hello@designstudio.com</span>
                    </div>
                  </div>

                  <div className="col-6 col-lg-3">
                    <div className="nav-column">
                      <h6>Services</h6>
                      <nav className="footer-nav" aria-label="Services">
                        <a href="#!">GYNECOLOGIE-OBSTETRIQUE</a>
                        <a href="#!">CHIRURGIE</a>
                        <a href="#!">ECHOGRAPHIE GRAVIDIQUE & ABDOMINALE</a>
                        <a href="#!">LABORATOIRE</a>
                        <a href="#!">PHARMACIE</a>
                        <a href="#!">MATERNITE : CPN, CPON, CPS</a>
                      </nav>
                    </div>
                  </div>

                  <div className="col-6 col-lg-3">
                    <div className="nav-column">
                      <h6>Resources</h6>
                      <nav className="footer-nav" aria-label="Resources">
                        <a href="#!">Design Blog</a>
                        <a href="#!">Style Guide</a>
                        <a href="#!">Free Assets</a>
                        <a href="#!">Tutorials</a>
                        <a href="#!">Inspiration</a>
                      </nav>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div className="footer-bottom">
        <div className="container">
          <div className="bottom-content" data-aos="fade-up" data-aos-delay="300">
            <div className="row align-items-center">
              <div className="col-lg-6">
                <div className="copyright">
                  <p>
                    © <span className="sitename">Polyclinique Yetu</span>. All rights reserved.
                  </p>
                </div>
              </div>

              <div className="col-lg-6">
                <div className="legal-links">
                  <div className="credits">
                    Designed by <a href="#!">Astre.b</a>.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
}

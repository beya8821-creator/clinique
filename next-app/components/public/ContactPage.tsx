import { createContactMessageAction } from "@/app/actions/public-forms";

type ContactPageProps = {
  status?: string;
};

function FormStatus({ status }: ContactPageProps) {
  if (status === "sent") {
    return <div className="sent-message d-block">Votre message a ete envoye. Merci.</div>;
  }

  if (status === "invalid") {
    return <div className="error-message d-block">Veuillez verifier les champs du formulaire.</div>;
  }

  if (status === "supabase-missing") {
    return <div className="error-message d-block">La base de donnees Supabase n&apos;est pas encore configuree.</div>;
  }

  if (status === "error") {
    return <div className="error-message d-block">Impossible d&apos;envoyer le message pour le moment.</div>;
  }

  return null;
}

export function ContactPage({ status }: ContactPageProps) {
  return (
    <main className="main contact-page">
      <section id="contact" className="contact section">
        <div className="container" data-aos="fade-up" data-aos-delay="100">
          <div className="row g-5">
            <div className="col-lg-5">
              <div className="contact-info-wrapper">
                <div className="contact-info-item" data-aos="fade-up" data-aos-delay="100">
                  <div className="info-icon"><i className="bi bi-geo-alt" /></div>
                  <div className="info-content"><h3>Adresse</h3><p>Polyclinique Yetu, Kinshasa</p></div>
                </div>
                <div className="contact-info-item" data-aos="fade-up" data-aos-delay="200">
                  <div className="info-icon"><i className="bi bi-envelope" /></div>
                  <div className="info-content"><h3>Email</h3><p>contact@polycliniqueyetu.cd</p></div>
                </div>
                <div className="contact-info-item" data-aos="fade-up" data-aos-delay="300">
                  <div className="info-icon"><i className="bi bi-headset" /></div>
                  <div className="info-content"><h3>Horaires</h3><p>Matin 6:00-7:30</p><p>Midi 12:00-13:00</p><p>Soir 16:00-18:00</p></div>
                </div>
              </div>
            </div>

            <div className="col-lg-7">
              <div className="contact-form-card" data-aos="fade-up" data-aos-delay="200">
                <h2>Envoyer un message</h2>
                <p className="mb-4">Notre equipe vous repondra dans les meilleurs delais.</p>
                <form action={createContactMessageAction} className="php-email-form" aria-label="Formulaire de contact">
                  <input type="text" name="website" tabIndex={-1} autoComplete="off" className="admin-honeypot" aria-hidden="true" />
                  <div className="row g-4">
                    <div className="col-md-6">
                      <input type="text" className="form-control" name="name" placeholder="Votre nom" required />
                    </div>
                    <div className="col-md-6">
                      <input type="email" className="form-control" name="email" placeholder="Votre email" required />
                    </div>
                    <div className="col-12">
                      <input type="text" className="form-control" name="subject" placeholder="Sujet" required />
                    </div>
                    <div className="col-12">
                      <textarea className="form-control" name="message" placeholder="Votre message" rows={6} required />
                    </div>
                    <div className="col-12">
                      <FormStatus status={status} />
                    </div>
                    <div className="col-12">
                      <button type="submit" className="btn btn-submit">Envoyer le message</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  );
}

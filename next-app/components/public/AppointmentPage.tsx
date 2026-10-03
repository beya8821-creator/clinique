import { createAppointmentAction } from "@/app/actions/public-forms";

type AppointmentPageProps = {
  status?: string;
};

function AppointmentStatus({ status }: AppointmentPageProps) {
  if (status === "sent") {
    return <div className="sent-message d-block">Votre demande de rendez-vous a ete envoyee.</div>;
  }

  if (status === "invalid") {
    return <div className="error-message d-block">Veuillez verifier les informations du rendez-vous.</div>;
  }

  if (status === "supabase-missing") {
    return <div className="error-message d-block">La base de donnees Supabase n&apos;est pas encore configuree.</div>;
  }

  if (status === "error") {
    return <div className="error-message d-block">Impossible d&apos;enregistrer le rendez-vous pour le moment.</div>;
  }

  return null;
}

export function AppointmentPage({ status }: AppointmentPageProps) {
  return (
    <main className="main contact-page appointment-page">
      <section className="contact section">
        <div className="container" data-aos="fade-up" data-aos-delay="100">
          <div className="row justify-content-center">
            <div className="col-lg-9">
              <div className="contact-form-card" data-aos="fade-up" data-aos-delay="200">
                <h2>Prendre rendez-vous</h2>
                <p className="mb-4">Remplissez le formulaire et l&apos;equipe de la Polyclinique Yetu vous recontactera.</p>
                <form action={createAppointmentAction} className="php-email-form" aria-label="Formulaire de rendez-vous">
                  <div className="row g-4">
                    <div className="col-md-6">
                      <input type="text" className="form-control" name="name" placeholder="Nom complet" required />
                    </div>
                    <div className="col-md-6">
                      <input type="email" className="form-control" name="email" placeholder="Email" required />
                    </div>
                    <div className="col-md-6">
                      <input type="tel" className="form-control" name="phone" placeholder="Telephone" required />
                    </div>
                    <div className="col-md-6">
                      <select className="form-control" name="department" defaultValue="">
                        <option value="" disabled>Service souhaite</option>
                        <option value="Medecine interne">Medecine interne</option>
                        <option value="Pediatrie">Pediatrie</option>
                        <option value="Gynecologie">Gynecologie</option>
                        <option value="Urgence">Urgence</option>
                        <option value="Laboratoire">Laboratoire</option>
                      </select>
                    </div>
                    <div className="col-md-6">
                      <input type="date" className="form-control" name="appointmentDate" />
                    </div>
                    <div className="col-md-6">
                      <input type="time" className="form-control" name="appointmentTime" />
                    </div>
                    <div className="col-12">
                      <input type="text" className="form-control" name="doctor" placeholder="Medecin souhaite, si connu" />
                    </div>
                    <div className="col-12">
                      <textarea className="form-control" name="message" placeholder="Votre message" rows={5} />
                    </div>
                    <div className="col-12">
                      <AppointmentStatus status={status} />
                    </div>
                    <div className="col-12">
                      <button type="submit" className="btn btn-submit">Envoyer la demande</button>
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

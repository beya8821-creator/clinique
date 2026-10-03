import Link from "next/link";

import { cmsSections, pageSlugs, sampleMedia } from "./admin-data";

export function ContentSectionToolbar({ addHref, label }: { addHref: string; label: string }) {
  return (
    <div className="admin-content-toolbar">
      <div>
        <strong>{label}</strong>
        <span>Consultez les sections existantes ou ajoutez un nouveau bloc de contenu.</span>
      </div>
      <Link href={addHref} className="admin-primary-action">
        <i className="bi bi-plus-lg" aria-hidden="true" />
        Ajouter
      </Link>
    </div>
  );
}

export function AddContentSectionForm({ pageName }: { pageName: string }) {
  return (
    <form className="admin-form-panel admin-add-section-form">
      <div className="admin-panel-header">
        <h2>Ajouter une section - {pageName}</h2>
        <span className="admin-badge">Brouillon</span>
      </div>
      <div className="admin-form-row">
        <label>
          Nom de la section
          <input placeholder="Ex: Bloc urgence, service mis en avant..." />
        </label>
        <label>
          Ordre d&apos;affichage
          <input type="number" min="1" placeholder="1" />
        </label>
      </div>
      <label>
        Titre
        <input placeholder="Titre visible sur le site public" />
      </label>
      <label>
        Sous-titre
        <textarea rows={2} placeholder="Texte court de presentation" />
      </label>
      <label>
        Description
        <textarea rows={5} placeholder="Description complete de la section" />
      </label>
      <div className="admin-form-row">
        <label>
          Texte du bouton
          <input placeholder="Ex: En savoir plus" />
        </label>
        <label>
          Lien du bouton
          <input placeholder="/contact" />
        </label>
      </div>
      <div className="admin-form-row">
        <label>
          Image
          <input type="file" accept=".jpg,.jpeg,.png,.webp,.gif,.svg" />
        </label>
        <label>
          Statut
          <select defaultValue="draft">
            <option value="draft">Brouillon</option>
            <option value="published">Publie</option>
          </select>
        </label>
      </div>
      <div className="admin-form-actions">
        <button type="button">Enregistrer la section</button>
        <button type="button" className="admin-secondary-action">Enregistrer en brouillon</button>
      </div>
    </form>
  );
}

export function CmsSectionsForm({ pageName = "Home" }: { pageName?: string }) {
  return (
    <div className="admin-stack">
      {cmsSections.map((section) => (
        <form className="admin-form-panel admin-section-editor" key={section.label}>
          <div className="admin-form-content">
            <div className="admin-panel-header">
              <h2>
                {pageName} - {section.label}
              </h2>
              <span className="admin-badge success">Sauvegarde</span>
            </div>
            <label>
              Titre
              <input defaultValue={section.title} />
            </label>
            <label>
              Sous-titre
              <textarea rows={2} defaultValue="Texte court de presentation de la section." />
            </label>
            <label>
              Description
              <textarea rows={4} defaultValue="Contenu CMS a synchroniser avec Supabase pendant la prochaine mission." />
            </label>
            <div className="admin-form-row">
              <label>
                Texte du bouton
                <input defaultValue="Enregistrer" />
              </label>
              <label>
                Lien du bouton
                <input defaultValue="/contact" />
              </label>
            </div>
            <label>
              Image
              <input defaultValue={section.image} />
            </label>
            <button type="button">Enregistrer cette section</button>
          </div>
          <aside className="admin-preview">
            <img src={`/${section.image}`} alt="" />
            <strong>{section.title}</strong>
            <span>Apercu rapide de la section publique.</span>
          </aside>
        </form>
      ))}
    </div>
  );
}

export function CmsSectionsList({ editBaseHref, pageName = "Home" }: { editBaseHref: string; pageName?: string }) {
  return (
    <div className="admin-sections-list">
      {cmsSections.map((section, index) => (
        <article className="admin-section-row" key={section.label}>
          <div className="admin-section-row-main">
            <img className="admin-section-thumb" src={`/${section.image}`} alt="" />
            <span className="admin-section-order">{index + 1}</span>
            <div>
              <h2>{section.label}</h2>
              <p>{section.title}</p>
              <span className="admin-section-meta">{pageName} · Publie · Image configuree</span>
            </div>
          </div>
          <div className="admin-section-actions">
            <Link href={`${editBaseHref}?section=${encodeURIComponent(section.label)}`} className="admin-table-action">
              Modifier
            </Link>
            <button type="button" className="admin-danger">
              Supprimer
            </button>
          </div>
        </article>
      ))}
    </div>
  );
}

export function CmsSectionEditForm({
  backHref,
  pageName = "Home",
  sectionLabel,
}: {
  backHref: string;
  pageName?: string;
  sectionLabel?: string;
}) {
  const selectedSection = cmsSections.find((section) => section.label === sectionLabel) ?? cmsSections[0];

  return (
    <div className="admin-stack">
      <div className="admin-content-toolbar">
        <div>
          <strong>Modification de section</strong>
          <span>
            Vous modifiez uniquement la section selectionnee. Les autres sections restent disponibles depuis la liste.
          </span>
        </div>
        <Link href={backHref} className="admin-secondary-action">
          Retour a la liste
        </Link>
      </div>

      <form className="admin-form-panel admin-section-editor">
        <div className="admin-form-content">
          <div className="admin-panel-header">
            <h2>
              {pageName} - {selectedSection.label}
            </h2>
            <span className="admin-badge success">Sauvegarde</span>
          </div>
          <label>
            Titre
            <input defaultValue={selectedSection.title} />
          </label>
          <label>
            Sous-titre
            <textarea rows={2} defaultValue="Texte court de presentation de la section." />
          </label>
          <label>
            Description
            <textarea rows={4} defaultValue="Contenu CMS a synchroniser avec Supabase pendant la prochaine mission." />
          </label>
          <div className="admin-form-row">
            <label>
              Texte du bouton
              <input defaultValue="Enregistrer" />
            </label>
            <label>
              Lien du bouton
              <input defaultValue="/contact" />
            </label>
          </div>
          <label>
            Image
            <input defaultValue={selectedSection.image} />
          </label>
          <button type="button">Enregistrer cette section</button>
        </div>
        <aside className="admin-preview">
          <img src={`/${selectedSection.image}`} alt="" />
          <strong>{selectedSection.title}</strong>
          <span>Apercu rapide de la section publique.</span>
        </aside>
      </form>
    </div>
  );
}

export function PagesEditor() {
  return (
    <div className="admin-editor-grid">
      <section className="admin-panel">
        <h2>Pages avancees</h2>
        <div className="admin-stack compact">
          {pageSlugs.map((slug) => (
            <a href="#!" key={slug}>
              {slug}
            </a>
          ))}
        </div>
      </section>
      <section className="admin-panel">
        <h2>Editer index</h2>
        <textarea rows={16} defaultValue="<section>HTML content will be loaded from Supabase.</section>" />
        <button type="button">Enregistrer le HTML</button>
      </section>
    </div>
  );
}

export function MediaManager() {
  return (
    <div className="admin-stack">
      <form className="admin-form-panel">
        <label>
          Uploader des fichiers
          <input type="file" multiple />
        </label>
        <label className="admin-check">
          <input type="checkbox" defaultChecked />
          <span>Ajouter les images uploadees au Hero Slider</span>
        </label>
        <button type="button">Uploader media</button>
      </form>
      <div className="admin-media-grid">
        {sampleMedia.map((item) => (
          <article className="admin-media-card" key={item.path}>
            <img src={item.path} alt={item.name} />
            <strong>{item.name}</strong>
            <span>{item.mime}</span>
            <input readOnly value={item.path} />
            <button type="button" className="admin-danger">
              Supprimer
            </button>
          </article>
        ))}
      </div>
    </div>
  );
}

export function SettingsForm() {
  const settings = ["site_name", "contact_email", "contact_phone", "address", "footer_text", "meta_title", "meta_description", "meta_keywords"];
  return (
    <form className="admin-form-panel">
      <h2>Parametres du site</h2>
      {settings.map((setting) => (
        <label key={setting}>
          {setting.replaceAll("_", " ")}
          <input defaultValue="" />
        </label>
      ))}
      <button type="button">Enregistrer les parametres</button>
    </form>
  );
}

export function UsersForm() {
  return (
    <div className="admin-stack">
      <form className="admin-form-panel">
        <h2>Ajouter un utilisateur</h2>
        <input placeholder="Nom" />
        <input type="email" placeholder="Email" />
        <input type="password" placeholder="Mot de passe" />
        <select defaultValue="1">
          <option value="1">Admin</option>
          <option value="2">Editor</option>
        </select>
        <button type="button">Creer utilisateur</button>
      </form>
      <div className="admin-table-wrap">
        <table className="admin-table">
          <tbody>
            <tr>
              <td>Administrator</td>
              <td>admin@example.com</td>
              <td>admin</td>
            </tr>
            <tr>
              <td>Editor</td>
              <td>editor@example.com</td>
              <td>editor</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  );
}

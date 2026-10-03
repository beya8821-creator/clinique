const servicesHtml = String.raw`
<main class="main services-page">
  <section id="services" class="services section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        ${[
          ["/assets/img/health/cardiology-2.webp", "Cardiology Services", "fas fa-heartbeat", "Cardiology", "Comprehensive heart care with advanced diagnostic tools and treatment options for cardiovascular conditions.", "ECG Testing", "Heart Surgery"],
          ["/assets/img/health/neurology-3.webp", "Neurology Services", "fas fa-brain", "Neurology", "Expert neurological care for brain and nervous system disorders with state-of-the-art imaging technology.", "MRI Scans", "Stroke Care"],
          ["/assets/img/health/orthopedics-1.webp", "Orthopedics Services", "fas fa-bone", "Orthopedics", "Specialized bone and joint treatment including sports medicine and reconstructive surgery procedures.", "Joint Replacement", "Sports Medicine"],
          ["/assets/img/health/pediatrics-4.webp", "Pediatrics Services", "fas fa-child", "Pediatrics", "Dedicated healthcare for children from infancy through adolescence with specialized treatment protocols.", "Well-Child Visits", "Immunizations"],
          ["/assets/img/health/emergency-2.webp", "Emergency Services", "fas fa-ambulance", "Emergency Care", "24/7 emergency medical services with rapid response teams and critical care capabilities.", "Trauma Center", "Critical Care"],
          ["/assets/img/health/laboratory-3.webp", "Laboratory Services", "fas fa-microscope", "Laboratory Testing", "Advanced diagnostic laboratory services with comprehensive testing panels and rapid result delivery.", "Blood Tests", "Pathology"],
        ].map((service, index) => `
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="${200 + index * 50}">
          <div class="service-item">
            <div class="service-image">
              <img src="${service[0]}" alt="${service[1]}" class="img-fluid">
              <div class="service-overlay"><i class="${service[2]}"></i></div>
            </div>
            <div class="service-content">
              <h3>${service[3]}</h3>
              <p>${service[4]}</p>
              <div class="service-features">
                <span class="feature-item"><i class="fas fa-check"></i> ${service[5]}</span>
                <span class="feature-item"><i class="fas fa-check"></i> ${service[6]}</span>
              </div>
              <a href="/service-details" class="service-btn"><span>Learn More</span><i class="fas fa-arrow-right"></i></a>
            </div>
          </div>
        </div>`).join("")}
      </div>
    </div>
  </section>
</main>
`;

export function ServicesPage() {
  return <div dangerouslySetInnerHTML={{ __html: servicesHtml }} />;
}

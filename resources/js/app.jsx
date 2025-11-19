import React from 'react';
import { createRoot } from 'react-dom/client';
import './bootstrap';

// Import React Components
import Hero from './components/Hero';
import ProgramCard from './components/ProgramCard';
import TestimonialSlider from './components/TestimonialSlider';
import ContactForm from './components/ContactForm';
import OrderForm from './components/OrderForm';

// Initialize React components when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Hero Component
    const heroContainer = document.getElementById('react-hero');
    if (heroContainer) {
        const root = createRoot(heroContainer);
        root.render(<Hero />);
    }

    // Program Cards
    const programContainer = document.getElementById('react-programs');
    if (programContainer) {
        const root = createRoot(programContainer);
        root.render(<ProgramCard />);
    }

    // Testimonial Slider
    const testimonialContainer = document.getElementById('react-testimonials');
    if (testimonialContainer) {
        const root = createRoot(testimonialContainer);
        root.render(<TestimonialSlider />);
    }

    // Contact Form
    const contactContainer = document.getElementById('react-contact-form');
    if (contactContainer) {
        const root = createRoot(contactContainer);
        root.render(<ContactForm />);
    }

    // Order Form
    const orderContainer = document.getElementById('react-order-form');
    if (orderContainer) {
        const root = createRoot(orderContainer);
        root.render(<OrderForm />);
    }
});

// Keep existing vanilla JS for backward compatibility
// Mobile menu toggle
const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');

if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener('click', () => {
        const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
        mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
        mobileMenu.classList.toggle('hidden');
    });
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href === '#') return;
        
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

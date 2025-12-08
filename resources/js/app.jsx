import React from "react";
import { createRoot } from "react-dom/client";
import "./bootstrap";

// Import React Components
import Hero from "./components/Hero";
import ProgramCard from "./components/ProgramCard";
import TestimonialSlider from "./components/TestimonialSlider";
import ContactForm from "./components/ContactForm";
import OrderForm from "./components/OrderForm";

// Component registry for auto-mounting
const COMPONENTS = {
    Hero,
    ProgramCard,
    TestimonialSlider,
    ContactForm,
    OrderForm,
};

/**
 * Auto-mount React components based on data-component attribute
 *
 * Usage in Blade:
 * <div data-component="OrderForm" data-props='{"programId": 1}'></div>
 */
function mountReactComponents() {
    document.querySelectorAll("[data-component]").forEach((container) => {
        const componentName = container.getAttribute("data-component");
        const Component = COMPONENTS[componentName];

        if (!Component) {
            console.warn(
                `React component "${componentName}" not found in registry`
            );
            return;
        }

        // Parse props from data-props attribute
        let props = {};
        try {
            const propsAttr = container.getAttribute("data-props");
            props = propsAttr ? JSON.parse(propsAttr) : {};
        } catch (error) {
            console.error(`Failed to parse props for ${componentName}:`, error);
        }

        // Mount component
        const root = createRoot(container);
        root.render(<Component {...props} />);
    });
}

// Initialize React components when DOM is ready
document.addEventListener("DOMContentLoaded", () => {
    mountReactComponents();
});

// Export for manual mounting if needed
export { COMPONENTS, mountReactComponents };

// Mobile menu toggle
const mobileMenuButton = document.getElementById("mobile-menu-button");
const mobileMenu = document.getElementById("mobile-menu");

if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener("click", () => {
        const isExpanded =
            mobileMenuButton.getAttribute("aria-expanded") === "true";
        mobileMenuButton.setAttribute("aria-expanded", !isExpanded);
        mobileMenu.classList.toggle("hidden");
    });
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        const href = this.getAttribute("href");
        if (href === "#") return;

        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
            target.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
        }
    });
});

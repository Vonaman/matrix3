function graceForm(agents) {
    return {
        openGrace: false,
        selectedId: null,
        agents: agents,
        get selectedAgent() {
            return this.agents.find(a => a.id == this.selectedId);
        }
    }
}
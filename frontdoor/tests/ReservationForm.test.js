import { mount } from '@vue/test-utils';
import ReservationForm from '@/components/ReservationForm.vue';

describe('ReservationForm.vue', () => {
  it('affiche un message derreur si les champs sont vides', async () => {
    const wrapper = mount(ReservationForm);
    await wrapper.find('button').trigger('click');

    expect(wrapper.text()).toContain('Veuillez remplir tous les champs.');
  });
});

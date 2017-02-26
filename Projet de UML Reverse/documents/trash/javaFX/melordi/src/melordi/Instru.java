package melordi;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.beans.property.IntegerProperty;
import javafx.beans.property.SimpleIntegerProperty;
import javax.sound.midi.MidiSystem;
import javax.sound.midi.MidiChannel;
import javax.sound.midi.MidiUnavailableException;
import javax.sound.midi.Synthesizer;

public class Instru {
    
    private IntegerProperty volume = new SimpleIntegerProperty(100);; 
    
    private Synthesizer synthetiser;
    private final MidiChannel Channel;
    
    public Instru(){
        
        try {
            //On récupère le synthétiseur, on l'ouvre et on obtient un Channel
            synthetiser = MidiSystem.getSynthesizer();
            synthetiser.open();
        } catch (MidiUnavailableException ex) {
            Logger.getLogger(Instru.class.getName()).log(Level.SEVERE, null, ex);
        }
        Channel = synthetiser.getChannels()[0];
        
        //On initialise l'instrument 0 (le piano) pour le Channel
	Channel.programChange(0);
    }
    
// REQUETES
    
    public IntegerProperty getVolume() {
        return volume;
    }
    
// COMMANDES
    
    //Joue la note dont le numéro est en paramètre
    public void note_on(int note){
        Channel.noteOn(note, volume.get());
    }
    //Arrête de jouer la note dont le numéro est en paramètre
    public void note_off(int note){
        Channel.noteOff(note);
    }
    //Set le type d'instrument dont le numéro MIDI est précisé en paramètre
    public void set_instrument(int instru){
        Channel.programChange(instru);
    }
}